/****** Object:  Table [dbo].[descargos]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[descargos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[archivo] [varchar](50) NULL,
	[clave] [varchar](2) NULL,
	[anio] [varchar](4) NULL,
	[periodo] [varchar](4) NULL,
	[modificado] [varchar](50) NULL,
	[licencia] [int] NULL,
	[created_by] [int] NULL,
	[updated_by] [int] NULL,
	[created_at] [date] NULL,
	[updated_at] [date] NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
