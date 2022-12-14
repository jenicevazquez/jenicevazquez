/****** Object:  Table [dbo].[cuentasAduaneras]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[cuentasAduaneras](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[institucion] [int] NULL,
	[numeroCuenta] [varchar](17) NULL,
	[folioConstancia] [varchar](17) NULL,
	[fechaConstancia] [date] NULL,
	[tipocuenta] [varchar](250) NULL,
	[tipoGarantia] [varchar](250) NULL,
	[totalGarantia] [decimal](18, 2) NULL,
	[cantidadUMC] [decimal](18, 6) NULL,
	[partida_id] [int] NULL,
	[nivel] [varchar](3) NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_cuentasAduaneras] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
